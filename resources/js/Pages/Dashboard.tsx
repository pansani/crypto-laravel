import React, { useEffect, useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";
import CoinRow from "../Components/CoinRow";
import AddCoinForm from "../Components/AddCoinForm";
import axios from "axios";

interface Coin {
    id: number;
    rank: number;
    name: string;
    symbol: string;
    icon: string;
    price: number;
    change1h: number;
    change24h: number;
    change7d: number;
    market_cap: number;
    total_volume: number;
    ath: number;
    chart_data: {
        labels: string[];
        data: number[];
        color: string;
        backgroundColor: string;
    };
}

interface Props extends PageProps {
    coins: Coin[];
}

export default function Dashboard({ coins, auth }: Props) {
    const [coinList, setCoinList] = useState<Coin[]>(coins || []);

    const fetchUserCoins = () => {
        axios
            .get(`/user-coins`)
            .then((response) => {
                if (Array.isArray(response.data)) {
                    setCoinList(response.data);
                } else {
                    console.error("Unexpected response data:", response.data);
                }
            })
            .catch((error) => {
                console.error("Error fetching coins:", error);
            });
    };

    useEffect(() => {
        fetchUserCoins();
    }, []);

    const addCoin = (coin: Coin) => {
        setCoinList((prevCoinList) => [...prevCoinList, coin]);
    };

    const deleteCoin = (id: number) => {
        axios
            .delete(`/user-coins/${id}`)
            .then((response) => {
                if (response.status === 200) {
                    setCoinList((prevCoinList) =>
                        prevCoinList.filter((coin) => coin.id !== id)
                    );
                } else {
                    console.error("Failed to delete coin:", response.data);
                }
            })
            .catch((error) => {
                console.error("Error deleting coin:", error);
            });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard
                </h2>
            }
        >
            <div className="flex justify-end m-4 mr-16">
                <AddCoinForm addCoin={addCoin} />
            </div>
            <div className="flex justify-center">
                <div className="w-full max-w-6xl overflow-x-auto">
                    {" "}
                    <table className="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr className="bg-gray-100 border-b text-center">
                                <th className="py-4 px-6">#</th>
                                <th className="py-4 px-6">Coin</th>
                                <th className="py-4 px-6">Price</th>
                                <th className="py-4 px-6">24h</th>
                                <th className="py-4 px-6">Market Cap</th>
                                <th className="py-4 px-6">Total Volume</th>{" "}
                                <th className="py-4 px-6">Last 24 hours</th>
                                <th className="py-4 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {coinList.map((coin, index) => (
                                <CoinRow
                                    key={coin.id}
                                    coinNumber={index + 1}
                                    {...coin}
                                    onDelete={deleteCoin}
                                />
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
