package main

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"strings"
	"time"

	"gorm.io/driver/sqlite"
	"gorm.io/gorm"
)

type Coin struct {
	ID          uint        `gorm:"primaryKey"`
	Name        string      `json:"name"`
	Rank        int         `json:"rank"`
	Symbol      string      `json:"symbol"`
	Icon        string      `json:"icon"`
	Price       float64     `json:"price"`
	Change24h   float64     `json:"change24h"`
	MarketCap   float64     `json:"market_cap" gorm:"column:market_cap"`
	TotalVolume float64     `json:"total_volume" gorm:"column:total_volume"`
	Ath         float64     `json:"ath" gorm:"column:ath"`
	ChartData   string      `json:"chart_data" gorm:"column:chart_data;type:TEXT"`
	CreatedAt   time.Time   `json:"created_at"`
	UpdatedAt   time.Time   `json:"updated_at"`
	CoinPrices  []CoinPrice `gorm:"foreignKey:CoinID;references:ID"`
}

type CoinPrice struct {
	ID        uint      `gorm:"primaryKey"`
	CoinID    uint      `gorm:"index;not null" json:"coin_id"`
	Date      time.Time `gorm:"index"`
	Price     float64   `json:"price"`
	CreatedAt time.Time
	Coin      Coin `gorm:"foreignKey:CoinID;references:ID"`
}

type CoinMarketResponse struct {
	ID                       string  `json:"id"`
	Symbol                   string  `json:"symbol"`
	Name                     string  `json:"name"`
	Rank                     int     `json:"market_cap_rank"`
	Image                    string  `json:"image"`
	CurrentPrice             float64 `json:"current_price"`
	MarketCap                float64 `json:"market_cap"`
	TotalVolume              float64 `json:"total_volume"`
	Ath                      float64 `json:"ath"`
	PriceChangePercentage24h float64 `json:"price_change_percentage_24h"`
}

func FetchCoinData(coinIDs []string) ([]CoinMarketResponse, error) {
	var coinMarketResponses []CoinMarketResponse

	ids := strings.Join(coinIDs, ",")
	url := fmt.Sprintf("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=%s", ids)
	response, err := http.Get(url)
	if err != nil {
		return coinMarketResponses, err
	}
	defer response.Body.Close()

	if err := json.NewDecoder(response.Body).Decode(&coinMarketResponses); err != nil {
		return coinMarketResponses, err
	}

	return coinMarketResponses, nil
}

func main() {
	db, err := gorm.Open(sqlite.Open("../../database/database.sqlite"), &gorm.Config{})
	if err != nil {
		log.Fatalf("failed to connect database: %v", err)
	}

	if err := db.AutoMigrate(&Coin{}); err != nil {
		log.Fatalf("failed to migrate database schema for coins: %v", err)
	}

	createCoinPriceTableSQL := `
	CREATE TABLE IF NOT EXISTS coin_prices (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		coin_id INTEGER NOT NULL,
		date DATETIME NOT NULL,
		price REAL NOT NULL,
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		FOREIGN KEY (coin_id) REFERENCES coins (id)
	);`

	if err := db.Exec(createCoinPriceTableSQL).Error; err != nil {
		log.Fatalf("failed to create coin_prices table: %v", err)
	}

	coinIDs := []string{
		"bitcoin", "ethereum", "litecoin", "ripple", "cardano", "polkadot", "binancecoin",
		"chainlink", "stellar", "usd-coin", "uniswap", "dogecoin", "wrapped-bitcoin", "bitcoin-cash",
		"vechain", "terra-luna", "solana", "tron", "tezos", "monero", "cosmos", "iota", "eos",
		"ftx-token", "maker", "aave", "compound", "algorand", "dash", "zcash",
	}

	coinMarketResponses, err := FetchCoinData(coinIDs)
	if err != nil {
		log.Fatalf("failed to fetch coin data: %v", err)
	}

	for _, coinMarketResponse := range coinMarketResponses {
		var coin Coin
		result := db.Where("symbol = ?", coinMarketResponse.Symbol).First(&coin)
		if result.Error != nil {
			if result.Error == gorm.ErrRecordNotFound {
				coin = Coin{
					Name:      coinMarketResponse.Name,
					Symbol:    coinMarketResponse.Symbol,
					Icon:      coinMarketResponse.Image,
					Price:     coinMarketResponse.CurrentPrice,
					MarketCap: coinMarketResponse.MarketCap,
				}
				if err := db.Create(&coin).Error; err != nil {
					log.Printf("failed to create coin data for %s: %v", coin.Name, err)
					continue
				}
			} else {
				log.Printf("failed to find coin data for %s: %v", coinMarketResponse.Name, result.Error)
				continue
			}
		}

		coinPrice := CoinPrice{
			CoinID: coin.ID,
			Date:   time.Now().UTC(),
			Price:  coinMarketResponse.CurrentPrice,
		}
		if err := db.Create(&coinPrice).Error; err != nil {
			log.Printf("failed to store coin price for %s: %v", coin.Name, err)
			continue
		}
	}

	fmt.Println("Coin data populated successfully!")
}
