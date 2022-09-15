<h2>Purchases:</h2>
<table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th scope="col" class="p-6 text-left">
            Date
        </th>
        <th scope="col" class="p-6 text-left">
            Stock
        </th>
        <th scope="col" class="p-6 text-right">
            Price
        </th>
        <th scope="col" class="p-6 text-right">
            Amount
        </th>

    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    @foreach ($data->getPurchases() as $purchase)
        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                {{ $purchase->created_at }}
            </td>
            <td class="py-4 px-6 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300">
                <a href="/stock?id={{ $purchase->stock_id }}">
                    {{ $purchase->symbol }}
                </a>
            </td>
            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                {{ number_format($purchase->price/100, 2) }}
            </td>
            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                {{ $purchase->amount }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<div>
    @if ($data->getSales())
        <div class="p-6 bg-white border-b border-gray-200">
            <h2>Sales:</h2>
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="p-6 text-left">
                        Date
                    </th>
                    <th scope="col" class="p-6 text-left">
                        Stock
                    </th>
                    <th scope="col" class="p-6 text-right">
                        Price
                    </th>
                    <th scope="col" class="p-6 text-right">
                        Amount
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach ($data->getSales() as $sale)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                            {{ $sale->created_at }}
                        </td>
                        <td class="py-4 px-6 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300">
                            <a href="/stock?id={{ $sale->stock_id }}">
                                {{ $sale->symbol }}
                            </a>
                        </td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            {{ number_format($sale->price/100, 2) }}
                        </td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            {{ $sale->amount }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
