package main

import (
	"encoding/json"
	"fmt"
	"log"
	"math/rand"
	"net/http"
	"strings"
	"time"

	"gorm.io/driver/sqlite"
	"gorm.io/gorm"
)

type Coin struct {
	ID          uint      `gorm:"primaryKey"`
	Name        string    `json:"name"`
	Rank        int       `json:"rank"`
	Symbol      string    `json:"symbol"`
	Icon        string    `json:"icon"`
	Price       float64   `json:"price"`
	Change24h   float64   `json:"change24h"`
	MarketCap   float64   `json:"market_cap" gorm:"column:market_cap"`
	TotalVolume float64   `json:"total_volume" gorm:"column:total_volume"`
	Ath         float64   `json:"ath" gorm:"column:ath"`
	ChartData   string    `json:"chart_data" gorm:"column:chart_data;type:TEXT"`
	CreatedAt   time.Time `json:"created_at"`
	UpdatedAt   time.Time `json:"updated_at"`
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

type ChartData struct {
	Labels          []string  `json:"labels"`
	Data            []float64 `json:"data"`
	Color           string    `json:"color"`
	BackgroundColor string    `json:"backgroundColor"`
}

func GenerateRandomChartData(currentPrice float64) (string, error) {
	chartLabels := []string{"Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"}
	chartDataValues := make([]float64, 7)
	for i := range chartDataValues {
		chartDataValues[i] = currentPrice * (1 + (rand.Float64()-0.5)/10)
	}

	colors := []string{
		"rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)",
		"rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)", "rgba(255, 159, 64, 1)",
		"rgba(99, 255, 132, 1)", "rgba(162, 54, 235, 1)", "rgba(206, 255, 86, 1)",
		"rgba(192, 75, 192, 1)", "rgba(102, 153, 255, 1)", "rgba(159, 255, 64, 1)",
		"rgba(132, 255, 99, 1)", "rgba(235, 162, 54, 1)", "rgba(86, 255, 206, 1)",
		"rgba(192, 192, 75, 1)", "rgba(255, 102, 153, 1)", "rgba(64, 255, 159, 1)",
		"rgba(255, 99, 255, 1)", "rgba(54, 162, 192, 1)", "rgba(255, 206, 153, 1)",
		"rgba(75, 192, 235, 1)", "rgba(153, 255, 102, 1)", "rgba(255, 159, 206, 1)",
		"rgba(99, 132, 255, 1)", "rgba(162, 192, 54, 1)", "rgba(206, 153, 255, 1)",
		"rgba(192, 75, 255, 1)", "rgba(102, 64, 255, 1)", "rgba(159, 99, 255, 1)",
		"rgba(132, 54, 255, 1)", "rgba(235, 192, 162, 1)", "rgba(86, 153, 255, 1)",
	}

	color := colors[rand.Intn(len(colors))]
	chartData := ChartData{
		Labels:          chartLabels,
		Data:            chartDataValues,
		Color:           color,
		BackgroundColor: strings.Replace(color, "1)", "0.2)", 1),
	}

	chartDataJSON, err := json.Marshal(chartData)
	if err != nil {
		return "", err
	}

	return string(chartDataJSON), nil
}

func FetchMultipleCoinsData(coinIDs []string) ([]Coin, error) {
	var coins []Coin

	ids := strings.Join(coinIDs, ",")
	url := fmt.Sprintf("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=%s", ids)
	response, err := http.Get(url)
	if err != nil {
		return coins, err
	}
	defer response.Body.Close()

	var coinMarketResponses []CoinMarketResponse
	if err := json.NewDecoder(response.Body).Decode(&coinMarketResponses); err != nil {
		return coins, err
	}

	for _, coinMarketResponse := range coinMarketResponses {
		chartDataJSON, err := GenerateRandomChartData(coinMarketResponse.CurrentPrice)
		if err != nil {
			return coins, err
		}

		coin := Coin{
			Name:        coinMarketResponse.Name,
			Symbol:      coinMarketResponse.Symbol,
			Icon:        coinMarketResponse.Image,
			Price:       coinMarketResponse.CurrentPrice,
			Change24h:   coinMarketResponse.PriceChangePercentage24h,
			MarketCap:   coinMarketResponse.MarketCap,
			Rank:        coinMarketResponse.Rank,
			TotalVolume: coinMarketResponse.TotalVolume,
			Ath:         coinMarketResponse.Ath,
			ChartData:   chartDataJSON,
		}
		coins = append(coins, coin)
	}

	return coins, nil
}

func main() {
	db, err := gorm.Open(sqlite.Open("../database/database.sqlite"), &gorm.Config{})
	if err != nil {
		log.Fatalf("failed to connect database: %v", err)
	}

	if err := db.AutoMigrate(&Coin{}); err != nil {
		log.Fatalf("failed to migrate database schema: %v", err)
	}

	coinIDs := []string{
		"bitcoin", "ethereum", "litecoin", "ripple", "cardano", "polkadot", "binancecoin",
		"chainlink", "stellar", "usd-coin", "uniswap", "dogecoin", "wrapped-bitcoin", "bitcoin-cash",
		"vechain", "terra-luna", "solana", "tron", "tezos", "monero", "cosmos", "iota", "eos",
		"ftx-token", "maker", "aave", "compound", "algorand", "dash", "zcash",
	}

	coins, err := FetchMultipleCoinsData(coinIDs)
	if err != nil {
		log.Fatalf("failed to fetch coin data: %v", err)
	}

	for _, coin := range coins {
		if err := db.Create(&coin).Error; err != nil {
			log.Printf("failed to store coin data for %s: %v", coin.Name, err)
			continue
		}

		fmt.Printf("Coin data for %s stored successfully!\n", coin.Name)
	}
}
