import React from "react";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/shadcn/ui/dropdown-menu";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrashAlt, faShoppingCart } from "@fortawesome/free-solid-svg-icons";
import { Line } from "react-chartjs-2";
import { Card, CardContent } from "@/shadcn/ui/card";
import {
    Chart as ChartJS,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Tooltip,
    Legend,
    ChartData as ChartJSData,
    ChartOptions,
    TooltipItem,
} from "chart.js";

ChartJS.register(
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Tooltip,
    Legend
);

interface ChartData {
    labels: string[];
    data: number[];
    color: string;
    backgroundColor: string;
}

interface CoinRowProps {
    id: number;
    coinNumber: number;
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
    chart_data: ChartData;
    onDelete: (id: number) => void;
}

const CoinRow: React.FC<CoinRowProps> = ({
    id,
    coinNumber,
    rank,
    name,
    symbol,
    icon,
    price,
    change1h,
    change24h,
    change7d,
    market_cap,
    total_volume,
    ath,
    chart_data,
    onDelete,
}) => {
    const data: ChartJSData<"line"> = {
        labels: chart_data.labels,
        datasets: [
            {
                label: "Value",
                data: chart_data.data,
                borderColor: chart_data.color,
                backgroundColor: chart_data.backgroundColor,
                fill: false,
                tension: 0.1,
            },
        ],
    };

    const options: ChartOptions<"line"> = {
        scales: {
            x: {
                display: false,
            },
            y: {
                display: false,
            },
        },
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: function (context: TooltipItem<"line">) {
                        return `Value: ${context.raw}`;
                    },
                },
            },
        },
    };

    const formatNumber = (number: number) => {
        return new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
        }).format(number);
    };

    const formatPercent = (number: number) => {
        return `${number.toFixed(2)}%`;
    };

    return (
        <tr className="border-b hover:bg-gray-100">
            <td className="py-2 px-4 text-gray-800">{coinNumber}</td>
            <td className="py-2 px-4 flex items-center">
                <img src={icon} alt={name} className="w-6 h-6 mr-2" />
                <div className="flex flex-col">
                    <span className="text-gray-800">{name}</span>
                    <span className="text-sm text-gray-500">{symbol}</span>
                </div>
            </td>
            <td className="py-2 px-4 text-gray-800">{formatNumber(price)}</td>
            <td
                className={`py-2 px-4 ${
                    change24h < 0 ? "text-red-500" : "text-green-500"
                }`}
            >
                {formatPercent(change24h)}
            </td>
            <td className="py-2 px-4 text-gray-800">
                {formatNumber(market_cap)}
            </td>
            <td className="py-2 px-4 text-gray-800">
                {formatNumber(total_volume)}
            </td>
            <td className="py-2 px-4">
                <div className="w-24 h-12">
                    <Line data={data} options={options} />
                </div>
            </td>
            <td className="py-2 px-4">
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <button className="focus:outline-none">
                            <span className="sr-only">Options</span>
                            ...
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                        <DropdownMenuItem
                            className="cursor-pointer"
                            onClick={() => onDelete(id)}
                        >
                            <FontAwesomeIcon
                                icon={faTrashAlt}
                                className="text-red-500 mr-2"
                            />
                            Remover
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem className="cursor-pointer">
                            <FontAwesomeIcon
                                icon={faShoppingCart}
                                className="text-green-500 mr-2"
                            />
                            Comprar
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </td>
        </tr>
    );
};

export default CoinRow;
