@php
  $title = isset($title) && !empty($title) ? $title : '';
  $typ = isset($typ) && !empty($typ) ? $typ : '/contacto-gracias';
  $faq_tab = isset($faq_tab) && !empty($faq_tab) ? $faq_tab : [];
  $contact_tab = isset($contact_tab) && !empty($contact_tab) ? $contact_tab : [];

  $icon_pin = themosis_assets() . '/images/icons/violet_pin.svg';
  $icon_phone = themosis_assets() . '/images/icons/violet_phone.svg';
  $icon_whatsapp = themosis_assets() . '/images/icons/violet_whatsapp.svg';
  $icon_mail = themosis_assets() . '/images/icons/violet_mail.svg';
  $icon_caret = themosis_assets() . '/images/icons/black_chevron-down.svg';

  $first_category = $faq_tab['categories'][0];
@endphp

<section class="help-center">
  <div class="help-center__container container">
    <h1 class="help-center__title">
      {{ $title }}
    </h1>
    <div class="help-center__tabs">
      <ul class="help-center__selectors">
        <li class="help-center__selector">
          <a
            class="help-center__selector-link"
            href="#faq"
          >{{ $faq_tab['title'] }}</a>
        </li>
        <li class="help-center__selector">
          <a
            class="help-center__selector-link"
            href="#contacto"
          >{{ $contact_tab['title'] }}</a>
        </li>
      </ul>
      <div class="help-center__tab-panel--faq" id="faq">
        <div class="help-center__faq-mobile-accordion">
          <div class="help-center__faq-mobile-accordion-header">
            <span class="help-center__faq-mobile-accordion-text">
              @if(
                isset($first_category['icon']) &&
                !empty($first_category['icon']) &&
                isset($first_category['icon']['url']) &&
                !empty($first_category['icon']['url'])
              )
              <img
                class="help-center__faq-selector-icon"
                src="{{ $first_category['icon']['url'] }}"
                alt="{{ $first_category['icon']['alt'] ?? 'Icono de categoría' }}"
                width="20"
                height="20"
                loading="lazy"
              />
              @endif
              {{ $first_category['title'] }}
            </span>
            <img
              class="help-center__faq-mobile-accordion-icon"
              src="{{ $icon_caret }}"
              alt="Icono acordeon"
              width="20"
              height="20"
            />
          </div>
          <div class="help-center__faq-mobile-accordion-options hidden">
            @foreach($faq_tab['categories'] as $category)
            <span
              class="
                help-center__faq-mobile-accordion-option
                {{ $loop->index == 0 ? 'help-center__faq-mobile-accordion-option--active' : '' }}
              "
            >
              @if(
                isset($category['icon']) &&
                !empty($category['icon']) &&
                isset($category['icon']['url']) &&
                !empty($category['icon']['url'])
              )
              <img
                class="help-center__faq-selector-icon"
                src="{{ $category['icon']['url'] }}"
                alt="{{ $category['icon']['alt'] ?? 'Icono de categoría' }}"
                width="20"
                height="20"
                loading="lazy"
              />
              @endif
              {{ $category['title'] }}
            </span>
            @endforeach
          </div>
        </div>
        <div class="help-center__faq-tabs">
          <ul class="help-center__faq-selectors">
            @foreach ($faq_tab['categories'] as $category)
            <li class="help-center__faq-selector">
              <a class="help-center__faq-selector-link" href="#faq-cat-{{$loop->index}}">
                @if(
                  isset($category['icon']) &&
                  !empty($category['icon']) &&
                  isset($category['icon']['url']) &&
                  !empty($category['icon']['url'])
                )
                <img
                  class="help-center__faq-selector-icon"
                  src="{{ $category['icon']['url'] }}"
                  alt="{{ $category['icon']['alt'] ?? 'Icono de categoría' }}"
                  width="20"
                  height="20"
                  loading="lazy"
                />
                @endif
                {{ $category['title'] }}
              </a>
            </li>
            @endforeach
          </ul>
          @foreach($faq_tab['categories'] as $category)
          <div class="help-center__faq-questions" id="faq-cat-{{$loop->index}}">
            <div class="help-center__faq-accordion">
              @foreach($category['questions'] as $question)
              <h2 class="help-center__question-title">
                <span class="help-center__question-title-text">
                {{ $question['title'] }}
                </span>
                <span class="help-center__accordion-cross"></span>
              </h2>
              <div class="help-center__question-content">{!! $question['content'] !!}</div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="help-center__tab-panel--contact" id="contacto">
        <div class="help-center__contact-form">
          <v-contact-form
            :terms="{{json_encode($contact_tab['terms'])}}"
            :info="{{json_encode($contact_tab['info'])}}"
            :button="{{json_encode($contact_tab['button_text'])}}"
            typ="{{$typ}}"
          ></v-contact-form>
        </div>
        @if(isset($contact_tab['info']) && !empty($contact_tab['info']))
        <address class="help-center__contact-info">
          @if(isset($contact_tab['info']['title']) && !empty($contact_tab['info']['title']))
          <h2 class="help-center__info-title">{{$contact_tab['info']['title']}}</h2>
          @endif

          <div class="help-center__links">
            @if(
              isset($contact_tab['info']['address']) &&
              !empty($contact_tab['info']['address']) &&
              isset($contact_tab['info']['address']['title']) &&
              !empty($contact_tab['info']['address']['title'])
            )
            <a
              class="help-center__link"
              href="{{ $contact_tab['info']['address']['url'] }}"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="help-center__link-icon"
                src="{{ $icon_pin }}"
                alt="Icono de marcador de mapa"
                width="20"
                height="20"
                loading="lazy"
              />
              {{ $contact_tab['info']['address']['title'] }}
            </a>
            @endif
    
            @if(isset($contact_tab['info']['phone']) && !empty($contact_tab['info']['phone']))
            <a
              class="help-center__link"
              href="tel:{{ $contact_tab['info']['phone'] }}"
            >
              <img
                class="help-center__link-icon"
                src="{{ $icon_phone }}"
                alt="Icono de teléfono"
                width="20"
                height="20"
                loading="lazy"
              />
              {{ $contact_tab['info']['phone'] }}
            </a>
            @endif
    
            @if(isset($contact_tab['info']['whatsapp']) && !empty($contact_tab['info']['whatsapp']))
            @php
              $trim_whatsapp = str_replace(' ', '', $contact_tab['info']['whatsapp']);
              $formatted_whatsapp = str_replace('+', '', $trim_whatsapp);
            @endphp
            <a
              class="help-center__link"
              href="https://wa.me/{{ $formatted_whatsapp }}"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="help-center__link-icon"
                src="{{ $icon_whatsapp }}"
                alt="Icono de whatsapp"
                width="20"
                height="20"
                loading="lazy"
              />
              {{ $contact_tab['info']['whatsapp'] }}
            </a>
            @endif
    
            @if(isset($contact_tab['info']['email']) && !empty($contact_tab['info']['email']))
            <a
              class="help-center__link"
              href="mailto:{{ $contact_tab['info']['email'] }}"
            >
              <img
                class="help-center__link-icon"
                src="{{ $icon_mail }}"
                alt="Icono de carta"
                width="20"
                height="20"
                loading="lazy"
              />
              {{ $contact_tab['info']['email'] }}
            </a>
            @endif
          </div>
        </address>
        @endif
      </div>
    </div>
  </div>
</section>
