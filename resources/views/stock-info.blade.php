<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Stock') }}
            </h2>
            <div>${{ number_format($wallet/100, 2) }}</div>
        </div>
    </x-slot>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-6 text-left">
                                Stock
                            </th>
                            <th scope="col" class="p-6 text-left">
                                Company
                            </th>
                            <th scope="col" class="p-6 text-right">
                                Current Price
                            </th>
                            <th scope="col" class="p-6 text-right">
                                Price Change
                            </th>
                            <th scope="col" class="p-6 text-right">
                                Percent Change
                            </th>
                            <th scope="col" class="p-6 text-left">
                                Last Updates
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-4 px-6 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300">
                                {{ $stock->symbol }}
                            </td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $stock->company_name }}
                            </td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                {{ (float)$stock->current_price/100 }}
                            </td>
                            @if ($stock->change < 0)
                                <td class="py-4 px-6 text-sm font-medium text-red-400 whitespace-nowrap dark:text-red-400 text-right">
                            @else
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                    @endif
                                    {{ (float)$stock->change }}
                                </td>
                                @if ($stock->change < 0)
                                    <td class="py-4 px-6 text-sm font-medium text-red-400 whitespace-nowrap dark:text-red-400 text-right">
                                @else
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        @endif
                                        {{ (float)$stock->percent_change }}%
                                    </td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                        {{ date("Y-m-d  h:m:s", $stock->last_change_time) }}
                                    </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="py-10">
                    <div class="flex justify-between">
                        <iframe class="px-2"
                                src="https://widget.finnhub.io/widgets/stocks/chart?symbol={{ $stock->symbol }}&watermarkColor=%231db954&backgroundColor=%23222222&textColor=white"
                                height="300" width="500"
                        >
                        </iframe>
                        <iframe class="px-2"
                                src="https://widget.finnhub.io/widgets/recommendation?symbol={{ $stock->symbol }}"
                                height="300" width="500"
                        >
                        </iframe>
                    </div>
                </div>
                <hr>

                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <div class="text-red-700 px-7">
                            {{ $error }}
                        </div>

                    @endforeach
                @endif
                <div class="py-10 px-1">
                    <form method="POST" action="purchase">
                        @csrf

                        <input type="hidden" name="id" value="{{ $stock->id }}">
                        <input type="hidden" id="stock_price" value="{{ $stock->current_price }}">
                        <input type="hidden" id="wallet" value="{{ $wallet }}">
                        <input type="hidden" id="total_amount" value="{{ $amount }}">

                        <div class="flex justify-between">
                            <div>
                                <button type="submit" name="button" id="buy_button" value="buy"
                                        class="inline-block px-6 py-4 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg"
                                >
                                    Buy
                                </button>

                                <input type="number" name="amount" min="1" step="1" id="amount"
                                       class="w-40 text-right rounded-md"
                                       placeholder="Amount"
                                       onchange="change()"
                                />
                                <input readonly id="full_price" value="$"
                                       class="w-40 text-right"
                                >
                                <button type="submit" name="button" id="sell_button" value="sell"
                                        class="inline-block px-6 py-4 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg"
                                >
                                    Sell
                                </button>


                            </div>
                            <div class="flex justify-evenly px-4">
                                @if ($amount)
                                    <button type="submit" name="button" id="sell_all_button" value="sell_all"
                                            class="inline-block px-6 py-4 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg"
                                    >
                                        Sell All
                                    </button>
                                    <div>
                                        <ul>
                                            <li class="flex justify-between px-1">
                                                <div>Shares you own:</div>
                                                <div>{{ $amount }}</div>
                                            </li>
                                            <li class="flex justify-between px-1">
                                                <div>Total spend:</div>
                                                <div>${{ number_format($total_spend/100, 2) }}</div>
                                            </li>
                                            @if (($amount * $stock->current_price) > $total_spend)
                                                <li class="flex justify-between px-1">
                                                    <div>You'll gain:&ensp;</div>
                                                    <div>${{ ($amount * $stock->current_price/100) - $total_spend/100 }}
                                                        ({{ round(100*($amount * $stock->current_price - $total_spend)/$total_spend, 4) }}
                                                        %)
                                                    </div>
                                                </li>
                                            @elseif (($amount * $stock->current_price) < $total_spend)
                                                <li class="flex justify-between text-red-400 px-1">
                                                    <div>You'll lose:&ensp;</div>
                                                    <div>${{ $total_spend/100 - ($amount * $stock->current_price/100)}}
                                                        ({{ round(100*($total_spend - $amount * $stock->current_price)/$total_spend, 4) }}
                                                        %)
                                                    </div>
                                                </li>
                                        </ul>
                                    </div>
                                @endif

                            </div>

                            @endif
                        </div>

                    </form>
                    <script src="js/validations.js"></script>
                </div>
            </div>
        </div>
    </div>
    @if ($news)
        @include('news')
    @endif
</x-app-layout>
