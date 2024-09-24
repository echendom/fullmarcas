@if (!empty($socials))
    <div class="hero-home__socials">
        @foreach ($socials as $social)
            <a class="hero-home__social" href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
                <img class="hero-home__social-icon image-no-touch" src="{{ $social['icon']['url'] }}"
                    alt="{{ $social['icon']['alt'] }}" width="25" height="25" />
            </a>
        @endforeach
    </div>
@endif
