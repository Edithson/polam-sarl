<!-- About Section -->
<section id="apropos" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Image -->
            <div class="about-image">
                <div class="about-shape-1"></div>
                <div class="about-shape-2"></div>
                <div class="about-content">
                    <svg viewBox="0 0 400 400" class="w-full h-full">
                        <circle cx="200" cy="200" r="150" fill="#dcfce7"/>
                        <rect x="120" y="140" width="160" height="200" rx="10" fill="white"/>
                        <rect x="140" y="170" width="120" height="8" rx="4" fill="#16a34a"/>
                        <rect x="140" y="200" width="100" height="6" rx="3" fill="#e5e7eb"/>
                        <rect x="140" y="220" width="110" height="6" rx="3" fill="#e5e7eb"/>
                        <rect x="140" y="240" width="90" height="6" rx="3" fill="#e5e7eb"/>
                        {{-- <circle cx="200" cy="290" r="20" fill="#ec4899"/>
                        <path d="M190 290 L197 297 L212 282" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/> --}}
                        <img class="h-50 w-50" src="{{ $siteLogo ? asset('storage/' . $siteLogo) : asset('media/img/logo.png') }}" alt="Logo CINV-CORSA">
                    </svg>
                </div>
            </div>

            <!-- Content -->
            <div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-6">{{ __('home.about_title') }}</h2>
                <div class="space-y-5 text-gray-600 text-lg leading-relaxed">
                    <p>
                        <strong class="text-green-600 font-semibold">{{ $siteName }} </strong>{{ __('home.about_desc1') }}
                    </p>
                    <p>
                        {{ __('home.about_desc2') }}
                    </p>
                    <p>
                        {{ __('home.about_desc3') }} <strong>50% {{ __('home.about_desc4') }}</strong>, <strong>25% {{ __('home.about_desc5') }}</strong> et <strong>25% {{ __('home.about_desc6') }}</strong>, {{ __('home.about_desc7') }}
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{route('about')}}" class="btn-primary">{{ __('home.about_btn') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
