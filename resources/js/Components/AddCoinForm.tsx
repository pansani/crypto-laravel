import React, { useState, useEffect } from "react";
import { Input } from "@/shadcn/ui/input";
import { Button } from "@/shadcn/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/shadcn/ui/dialog";
import axios from "axios";

interface Coin {
    id: number;
    rank: number;
    name: string;
    symbol: string;
    price: number;
    icon: string;
    change1h: number;
    change24h: number;
    change7d: number;
    market_cap: number;
    total_volume: number;
    ath: number;
    chart_data: ChartData;
}

interface ChartData {
    labels: string[];
    data: number[];
    color: string;
    backgroundColor: string;
}

interface AddCoinFormProps {
    addCoin: (coin: Coin) => void;
}

const AddCoinForm: React.FC<AddCoinFormProps> = ({ addCoin }) => {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [search, setSearch] = useState("");
    const [coins, setCoins] = useState<Coin[]>([]);

    useEffect(() => {
        fetch("/coins/all")
            .then((response) => response.json())
            .then((data) => setCoins(data));
    }, []);

    const filteredCoins = coins.filter(
        (coin) =>
            coin.name.toLowerCase().includes(search.toLowerCase()) ||
            coin.symbol.toLowerCase().includes(search.toLowerCase())
    );

    const handleAddCoin = async (coin: Coin) => {
        try {
            await axios.post("/user-coins/add", { coin_id: coin.id });
            addCoin(coin);
            setDialogOpen(false);
        } catch (error) {
            console.error("Error adding coin:", error);
        }
    };

    return (
        <Dialog open={dialogOpen} onOpenChange={setDialogOpen}>
            <DialogTrigger asChild>
                <Button
                    variant="outline"
                    className="bg-blue-600 text-white hover:bg-blue-500 hover:text-white"
                >
                    Adicionar moeda
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[600px] max-h-[80vh] overflow-y-auto">
                <DialogHeader>
                    <DialogTitle>Add coins</DialogTitle>
                    <DialogDescription>
                        Search and select a coin to add it to your dashboard.
                    </DialogDescription>
                </DialogHeader>
                <div className="p-4">
                    <Input
                        placeholder="Search"
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        className="mb-4"
                    />
                    <div className="space-y-2">
                        {filteredCoins.map((coin) => (
                            <div
                                key={coin.id}
                                className="flex justify-between items-center p-2 hover:bg-gray-100 rounded cursor-pointer"
                                onClick={() => handleAddCoin(coin)}
                            >
                                <div className="flex items-center space-x-2">
                                    <img
                                        src={coin.icon}
                                        alt={`${coin.name} icon`}
                                        className="w-6 h-6"
                                    />
                                    <div>
                                        <p className="font-medium">
                                            {coin.name}
                                        </p>
                                        <p className="text-sm text-gray-500">
                                            {coin.symbol}
                                        </p>
                                    </div>
                                </div>
                                <div className="text-right">
                                    <p className="font-medium">{coin.price}</p>
                                    <p className="text-sm text-gray-500">
                                        Volume: {coin.total_volume}
                                    </p>
                                    <p className="text-sm text-gray-500">
                                        ATH: {coin.ath}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                <DialogFooter>
                    <Button
                        variant="outline"
                        onClick={() => setDialogOpen(false)}
                    >
                        Close
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
};

export default AddCoinForm;
