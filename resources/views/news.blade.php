<div class="pt-6 pb-12 bg-gray-300">
    <div id="card" class="">
        @if($news)
        <h2 class="text-center font-serif  uppercase text-4xl xl:text-5xl">Finance News</h2>
        @endif
        <!-- container for all cards -->
        <div class="container w-100 lg:w-4/5 mx-auto flex flex-col">
            <!-- card -->
            @foreach ($news as $article)
                <div v-for="card in cards" class="flex flex-col md:flex-row overflow-hidden
                                        bg-white rounded-lg shadow-xl  mt-4 w-100 mx-2">
                    <!-- media -->
                    <div class="h-64 w-auto md:w-1/2">
                        <a href="{{ $article->url }}" target="_blank">
                            <img class="inset-0 h-full w-full object-cover object-center"
                                 src="{{ $article->image }}"/>
                        </a>
                    </div>
                    <!-- content -->
                    <div class="w-full py-4 px-6 text-gray-800 flex flex-col justify-between">
                        <a href="{{ $article->url }}" target="_blank">
                            <h3 class="font-semibold text-lg leading-tight truncate">{{ $article->headline }}</h3>
                        </a>
                        <p class="mt-2">
                            {{  $article->summary }}
                        </p>
                        <p class="text-sm text-gray-700 uppercase tracking-wide font-semibold mt-2">
                            &bull; {{ date("Y-m-d", $article->datetime)  }}
                        </p>
                    </div>
                </div><!--/ card-->
            @endforeach
        </div><!--/ flex-->
    </div>
</div>
