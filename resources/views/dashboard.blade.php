<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Stocks') }}
            </h2>
            <div>${{ number_format($wallet/100, 2) }}</div>
        </div>
    </x-slot>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

{{--    <h4 class="text-center font-serif  uppercase text-4xl xl:text-5xl"> Stock Market Game</h4>--}}

    <div class="flex justify-center py-2">
        <div class="flex-row py-4">
        @if ($errors)
            @foreach ($errors->all() as $error)
                <div class="text-red-700 px-7">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <form action="/search" method="GET">
            <input type="text" name="symbol" placeholder="Enter Stock Symbol">
            <button type="submit"
                    class="inline-block px-2 py-4 bg-blue-600 text-white font-medium text-xs leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg"
            >
                Search
            </button>
        </form>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">


                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4 text-left">
                                Stock
                            </th>
                            <th scope="col" class="p-4 text-left">
                                Company
                            </th>
                            <th scope="col" class="p-4">
                                Current Price
                            </th>
                            <th scope="col" class="p-4">
                                Price Change
                            </th>
                            <th scope="col" class="p-4">
                                Percent Change
                            </th>
                            <th scope="col" class="p-4 text-left">
                                Last Updates
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        @foreach ($data as $stock)
                            <tr class="hover:border-green-600 dark:hover:border-green-300">
                                <td class="py-4 px-6 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300">
                                    <a href="/stock?id={{ $stock->id }}">
                                        {{ $stock->symbol }}
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="/stock?id={{ $stock->id }}">
                                        {{ $stock->company_name }}
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                    {{ $stock->current_price/100 }}
                                </td>
                                @if ($stock->change < 0)
                                    <td class="py-4 px-6 text-sm font-medium text-red-400 whitespace-nowrap dark:text-red-400 text-right">
                                @else
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        @endif
                                        {{ (float)($stock->change) }}
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
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {!! $data->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>
