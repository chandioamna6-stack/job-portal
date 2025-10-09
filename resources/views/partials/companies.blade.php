<section id="companies" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold">Top Companies Hiring</h2>
            <p class="text-gray-600">Discover companies actively hiring and explore their opportunities</p>
        </div>

        {{-- Swiper Slider --}}
        <div class="swiper companies-slider pb-12">
            <div class="swiper-wrapper">
                {{-- Company slides --}}
                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg"
                         alt="Microsoft" class="object-contain h-10 md:h-12 opacity-80 hover:opacity-100 transition">
                </div>

                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg"
                         alt="Apple" class="object-contain h-8 md:h-10 opacity-80 hover:opacity-100 transition">
                </div>

                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg"
                         alt="Google" class="object-contain h-10 md:h-12 opacity-80 hover:opacity-100 transition">
                </div>

                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png"
                         alt="Meta" class="object-contain h-8 md:h-10 opacity-80 hover:opacity-100 transition">
                </div>

                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg"
                         alt="Netflix" class="object-contain h-8 md:h-10 opacity-80 hover:opacity-100 transition">
                </div>

                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg"
                         alt="Amazon" class="object-contain h-8 md:h-10 opacity-80 hover:opacity-100 transition">
                </div>


                <div class="swiper-slide flex justify-center items-center p-4">
                    <img src="data:image/png;base64,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"
                         alt="Tesla" class="object-contain h-8 md:h-10 opacity-80 hover:opacity-100 transition">
                </div>
            </div>

            {{-- Pagination --}}
            <div class="swiper-pagination !static mt-6"></div>
        </div>
    </div>
</section>
