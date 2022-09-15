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
            Amount
        </th>

    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    @foreach ($stocks as $stock)
        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                {{ $stock->updated_at }}
            </td>
            <td class="py-4 px-6 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300">
                <a href="/stock?id={{ $stock->stock_id }}">
                    {{ $stock->symbol }}
                </a>
            </td>
            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                {{ $stock->amount }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
