<template>
  <div class="step1">
    <div class="step1__content">
      <h1 class="step1__stepper-title">{{ stepperTitle }}</h1>
      <div class="step1__form-container">
        <h2 v-if="title" class="step1__title">
          {{ title }}
        </h2>
        <div v-if="description" class="step1__description paragraph" v-html="description"></div>
        <validation-observer ref="form" v-slot="{ invalid }" slim>
          <form class="step1__form" @submit.prevent="handleSubmit">
            <div class="step1__details">
              <validation-provider
                name="trademark_name"
                :rules="requiresDenomination ? 'required' : ''"
                :bails="true"
                tag="div"
                class="form-input-field"
                v-slot="{ errors }"
              >
                <label
                  :class="[
                    'form-input-field__label',
                    errors.length ? 'form-input-field__label--error' : ''
                  ]"
                >
                  ¿Cómo se llama tu marca?
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['trademarkName']"
                    type="text"
                    :placeholder="!requiresDenomination ? 'Este dato no es requerido para una etiqueta' : 'Ingresa aquí'"
                    :disabled="!requiresDenomination"
                  />
                </label>
                <div class="form-input-field__errors" v-if="errors.length">
                  <span
                    class="paragraph paragraph--small form-input-field__error"
                    v-for="(error, index) in errors"
                    :key="index"
                  >
                    {{ error }}
                  </span>
                </div>
                <span class="paragraph paragraph--small form-input-field__hint" v-else>
                  Puede incluir letras, números y símbolos
                </span>
              </validation-provider>
              <validation-provider
                name="email"
                rules="required|email"
                :bails="true"
                tag="div"
                class="form-input-field"
                v-slot="{ errors }"
              >
                <label
                  :class="[
                    'form-input-field__label',
                    errors.length ? 'form-input-field__label--error' : ''
                  ]"
                >
                  ¿A qué correo te enviamos la información?
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['email']"
                    type="email"
                    placeholder="Ingresa aquí"
                  />
                </label>
                <div class="form-input-field__errors" v-if="errors.length">
                  <span
                    class="paragraph paragraph--small form-input-field__error"
                    v-for="(error, index) in errors"
                    :key="index"
                  >
                    {{ error }}
                  </span>
                </div>
                <span class="paragraph paragraph--small form-input-field__hint" v-else>
                  Ejemplo: mail@mail.com
                </span>
              </validation-provider>
              <!-- Phone -->
              <validation-provider
                name="phone"
                rules="required|numeric|min:11|max:11"
                :bails="true"
                tag="div"
                class="form-input-field"
                v-slot="{ errors }"
              >
                <label
                  :class="[
                    'form-input-field__label',
                    errors.length ? 'form-input-field__label--error' : ''
                  ]"
                >
                  ¿A qué número te llamamos?
                  <input
                    class="form-input-field__input"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    v-model="inputs['phone']"
                    type="tel"
                    maxlength="11"
                    placeholder="56 976543210"
                  />
                </label>
                <div class="form-input">
                  <span
                    class="paragraph paragraph--small form-input-field__hint"
                    v-if="!errors.length"
                  >
                    Ejemplo: 55 1234 5678
                  </span>
                </div>
                <div class="form-input">
                  <span
                    class="paragraph paragraph--small form-input-field__error"
                    v-if="errors.length"
                  >
                    {{ errors[0] }}
                  </span>
                </div>
              </validation-provider>

            </div>
            <div class="step1__trademark-type">
              <h3 class="step1__types-title" v-if="type_title">
                {{ type_title }}
              </h3>
              <div v-if="type_description" class="step1__types-description paragraph" v-html="type_description"></div>
              <validation-provider
                name="type"
                rules="required"
                :bails="true"
                tag="div"
                class="step1__types"
                v-slot="{ errors }"
              >
                <label
                  v-for="tm_type in types"
                  :key="tm_type['title']"
                  :class="[
                    tm_type['title'] === inputs['type'] ? 'step1__type--selected' : 'step1__type'
                  ]"
                >
                  <div class="step1__type-content">
                    <h4 class="step1__type-title">
                      {{ tm_type['title'] }}
                    </h4>
                    <span
                      class="step1__type-description paragraph"
                      v-if="tm_type['description']"
                      v-html="tm_type['description']"
                    ></span>
                    <span
                      class="step1__example-label"
                      v-if="tm_type['example_text'] || tm_type['example_img']"
                    >
                      Ejemplo:
                    </span>
                    <img
                      class="step1__example-image"
                      v-if="tm_type['example_img'] && tm_type['example_img']['url']"
                      :src="tm_type['example_img']['url']"
                      :alt="tm_type['example_img']['alt']"
                      loading="lazy"
                    />
                    <span 
                      class="step1__example-text"
                      v-else-if="tm_type['example_text']"
                    >
                      {{ tm_type['example_text'] }}
                    </span>
                  </div>
                  <div class="step1__type-input">
                    Seleccionar
                    <span class="step1__type-input-circle"></span>
                    <input
                      class="step1__type-input-radio"
                      type="radio"
                      :value="tm_type['title']"
                      v-model="inputs['type']"
                    />
                  </div>
                </label>
                <div class="step1__types-errors" v-if="errors.length">
                  <span
                    class="paragraph paragraph--small form-input-field__error"
                    v-for="(error, index) in errors"
                    :key="index"
                  >
                    {{ error }}
                  </span>
                </div>
              </validation-provider>
            </div>
            <div v-if="requiresImage" class="step1__image-input-container">
              <div
                class="step1__image-input-label paragraph"
                v-if="!inputs.fileValidated"
                v-html="file_input_title"
              >
              </div>
              <label
                class="step1__drop-area"
                v-if="!inputs.fileValidated"
                :data-active="dropZoneActive"
                @dragenter.prevent="setDropZoneActive"
                @dragover.prevent="setDropZoneActive"
                @dragleave.prevent="setDropZoneInactive"
                @drop.prevent="onDrop"
              >
                <img
                  class="step1__drop-area-placeholder"
                  :src="dropAreaPlaceholder"
                  alt="Icono de imagen"
                  loading="lazy"
                  width="60"
                  height="60"
                />
                <div class="step1__drop-area-label" v-html="file_input_label"></div>
                <div class="step1__drop-area-specs" v-html="file_input_specs"></div>

                <input type="file" name="trademark_file" class="step1__file-input" @change="onChangeFile" ref="trademark_file" />
              </label>
              <validation-provider
                name="image_filename"
                rules="required"
                :bails="true"
                tag="div"
                class="form-input-field step1__image-filename"
                v-slot="{ errors }"
              >
                <input
                  type="text"
                  class="step1__image-filename-input"
                  :value="inputs['trademarkFilename']"
                />
                <div class="form-input-field__errors step1__image-errors" v-if="errors.length">
                  <span
                    class="paragraph paragraph--small form-input-field__error"
                    v-for="(error, index) in errors"
                    :key="index"
                  >
                    {{ error }}
                  </span>
                </div>
              </validation-provider>
              <div
                v-if="inputs['fileValidated']"
                class="step1__brand-file"
              >
                <button class="step1__delete-file-button" @click="deleteFile">
                  <img
                    class="step1__delete-file-icon"
                    :src="deleteFileIcon"
                    alt="Icono eliminar"
                    width="24"
                    height="24"
                  />
                </button>
                <span class="step1__brand-filename">
                  {{ inputs['trademarkFilename'] }}
                  <img
                    v-if="inputs.storedFilename"
                    class="step1__file-check"
                    :src="greenCheck"
                    width="20"
                    height="20"
                    loading="lazy"
                  />
                </span>
                <span class="step1__brand-filesize">
                  {{ inputs['trademarkFilesize'] }}
                </span>
                <div class="step1__upload-progress">
                  <div class="step1__upload-progress-background">
                    <span class="step1__upload-progress-indicator" :style="{width: `${inputs.uploadPercentage}%`}"></span>
                  </div>
                  <span class="step1__upload-progress-value">{{ inputs.uploadPercentage }}%</span>
                </div>
              </div>
              <div class="step1__image-input-errors" v-if="imageError">
                <span class="paragraph paragraph--small form-input-field__error">
                  {{ imageError }}
                </span>
              </div>
              <validation-provider
                name="image_extra_info"
                v-if="requiresImageDescription"
                rules="required"
                :bails="true"
                tag="div"
                class="form-input-field step1__image-description"
                v-slot="{ errors }"
              >
                <label
                  :class="[
                    'form-contact__label',
                    'form-input-field__label',
                    errors.length ? 'form-input-field__label--error' : ''
                  ]"
                >
                  {{ file_details_label }}
                  <textarea
                    ref="textarea"
                    :disabled="loading"
                    class="form-input-field__input--textarea"
                    :class="errors.length ? 'form-input-field__input--error' : ''"
                    @input="resizeMsgInput"
                    v-model="inputs['imageExtraInfo']"
                    placeholder="Ingresa aquí"
                    rows="3"
                  ></textarea>
                </label>
                <div class="form-input-field__errors" v-if="errors.length">
                  <span
                    class="paragraph paragraph--small form-input-field__error"
                    v-for="(error, index) in errors"
                    :key="index"
                  >
                    {{ error }}
                  </span>
                </div>
              </validation-provider>
            </div>
          </form>
        </validation-observer>
      </div>
    </div>
    <img
      v-if="side_image"
      class="step1__image"
      :src="side_image['url']"
      :alt="side_image['alt']"
      width="520"
      height="550"
    />
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required, email, numeric, max } from 'vee-validate/dist/rules';
import prettyBytes from 'pretty-bytes';

extend('required', {
  ...required,
  message: 'Este campo es requerido'
});
extend('email', {
  ...email,
  message: 'Dirección de correo electrónico inválida'
});
extend('numeric', {
  ...numeric,
  message: 'Este campo debe ser numérico'
});
extend('max', {
  ...max,
  message: 'Este campo debe tener {length} numeros'
});

const baseUrl = '/cms/wp-admin/admin-ajax.php';

function preventDefaults(e) {
	e.preventDefault();
}
const events = ['dragenter', 'dragover', 'dragleave', 'drop'];

export default {
  name: 'Step1',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  props: [
    'title',
    'description',
    'side_image',
    'labels',
    'type_title',
    'type_description',
    'types',
    'file_details_label',
    'file_input_title',
    'file_input_label',
    'file_input_specs',
    'allowed_extensions',
    'maximum_kb',
    'minimum_dimensions'
  ],
  data() {
    return {
      inputs: {
        trademarkName: '',
        email: '',
        type: '',
        trademarkFile: '',
        trademarkFilename: '',
        trademarkFilesize: '',
        filenameInput: '',
        storedFilename: '',
        fileValidated: false,
        uploadPercentage: 0,
        imageExtraInfo: ''
      },
      greenCheck: `${themosis_assets}/images/icons/green_check.svg`,
      imageError: '',
      uploadingImage: false,
      dropAreaPlaceholder: `${themosis_assets}/images/dropzone_image.svg`,
      deleteFileIcon: `${themosis_assets}/images/icons/black_delete_file_icon.svg`,
      dropZoneActive: false,
      inActiveTimeout: null
    }
  },
  computed: {
    requiresImage() {
      if (!this.inputs['type']) {
        return false;
      }
      const { type } = this.inputs;
      const selectedType = this.types.find(({ title }) => type === title)
      if (!selectedType) {
        return false;
      }
      return selectedType.requiresImage;
    },
    requiresImageDescription() {
      if (!this.inputs['type']) {
        return false;
      }
      const { type } = this.inputs;
      const selectedType = this.types.find(({ title }) => type === title)
      if (!selectedType) {
        return false;
      }
      return selectedType.requiresImageDescription;
    },
    requiresDenomination() {
      if (!this.inputs['type']) {
        return true;
      }
      const { type } = this.inputs;
      const selectedType = this.types.find(({ title }) => type === title)
      if (!selectedType) {
        return true;
      }
      return selectedType.requiresDenomination;
    },
    ...mapState([
        'nextFlag',
        'stepperTitle',
        'globalInputs',
        'loading'
      ]
    )
  },
  beforeMount() {
    window.scrollTo({ top: 0 });
  },
  mounted() {
    events.forEach((eventName) => {
      document.body.addEventListener(eventName, preventDefaults);
    });
    const { step1 } = this.globalInputs;
    if (step1) {
      this.inputs = step1;
    }
    this.$watch('inputs.type', this.handleChangeType);
  },
  destroyed() {
    events.forEach((eventName) => {
      document.body.removeEventListener(eventName, preventDefaults);
    });
  },
  methods: {
    handleChangeType() {
      this.deleteFile();
      this.inputs.imageExtraInfo = '';
      if (!this.requiresDenomination) {
        this.inputs.trademarkName = '';
      }
    },
    resizeMsgInput() {
      let element = this.$refs["textarea"];

      let txtareaHeight = '70px';
      element.style.height = txtareaHeight;

      if (element.scrollHeight > 70) {
        txtareaHeight = element.scrollHeight + 'px';
      }

      element.style.height = txtareaHeight;
    },
    deleteFile() {
      this.inputs['trademarkFile'] = '';
      this.inputs['trademarkFilename'] = '';
      this.inputs['trademarkFilesize'] = '';
      this.inputs['storedFilename'] = '';
      this.inputs.uploadPercentage = 0;
      this.inputs.fileValidated = false;
      this.imageError = '';
      if (this.$refs.trademark_file) {
        this.$refs.trademark_file.value = '';
      }
    },
    async submitAndNext() {
      this.updateGlobalInputs({
        step1: this.inputs
      });
      this.setGlobalEmail(this.inputs['email']);
      this.setGlobalId('');
      try {
        const response = await this.submitData({
          action: 'step-1',
          method: 'post',
          payload: {
            trademark_name: this.inputs['trademarkName'],
            email: this.inputs['email'],
            telefono: this.inputs['phone'],
            type: this.inputs['type'],
            stored_filename: this.inputs['storedFilename'],
            image_extra_info: this.inputs['imageExtraInfo']
          }
        });

        const { data } = response;

        if (data.success) {
          this.setGlobalCategories(data.categories);
          this.setGlobalId(data.id);
          this.$router.push({name: 'categorias'});
        }
      } catch (error) {
        console.log('error in step1 submitAndNext:', error);
        this.stopLoading();
      }
    },
    async handleSubmit() {
      if (this.uploadingImage) {
        return;
      }
      const isValid = await this.$refs.form.validate();
      let isValidImage = true;
      if (this.requiresImage) {
        isValidImage = this.inputs.fileValidated;
      }

      if (!isValid || !isValidImage) {
        const el = document.querySelector(".form-input-field__error:first-of-type");
        el.scrollIntoView({ behavior: "smooth", block: 'center' });
        return
      };

      this.submitAndNext();
    },
    submitFile() {
      let formData = new FormData();
      const ctx = this;
      formData.append('file', this.inputs['trademarkFile']);
      this.uploadingImage = true;
      axios.post(`${baseUrl}?action=trademark-logo`,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          },
          onUploadProgress: function(progressEvent) {
            this.inputs.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ) );
          }.bind(this)
        }
      ).then(function(response) {
        ctx.inputs['storedFilename'] = response.data.stored_image_url;
      })
      .catch(function(error) {
        console.log('FAILURE!!', error);
      })
      .finally(function() {
        ctx.uploadingImage = false;
      });
    },
    async validateImage(file) {
      const { allowed_extensions, maximum_kb, minimum_dimensions } = this;

      // Validate file extension
      const name = file.name;
      const lastDot = name.lastIndexOf('.');
      const imageExtension = name.substring(lastDot + 1);
      if (!allowed_extensions.includes(imageExtension.toLowerCase())) {
        this.imageError = 'Tipo de archivo no permitido';
        return false;
      }

      // Validate file size
      const fileSize = file.size / 1024;
      if (fileSize > maximum_kb) {
        this.imageError = 'El archivo es demasiado pesado';
        return false;
      }

      // Validate image minimum dimensions
      const { width, height } = minimum_dimensions;
      // Validate dimensions only if the file is an image.
      if (/\.(jpg|svg|jpeg|png|bmp|gif)$/i.test(file.name)) {
        const URL = window.URL || window.webkitURL;
        const valid = await new Promise(resolve => {
          const image = new Image();
          image.onerror = function () { return resolve(false); };
          image.onload = function () { return resolve(image.width >= Number(width) && image.height >= Number(height)) };
          image.src = URL.createObjectURL(file);
        });
        if (!valid) {
          this.imageError = 'El archivo no cumple con las dimensiones mínimas';
          return false;
        }
      }

      this.imageError = '';
      return true;
    },
    async onChangeFile(e) {
      this.inputs.uploadPercentage = 0;
      this.inputs.fileValidated = false;
      const files = e.target.files;
      const valid = await this.validateImage(files[0]);
      this.inputs.fileValidated = valid;
      if (files.length > 0) {
        const file = files[0];
        this.inputs['trademarkFile'] = file;
        this.inputs['trademarkFilename'] = file.name;
        this.inputs['trademarkFilesize'] = prettyBytes(file.size);
        if (valid) {
          this.submitFile();
        }
      } else {
        this.inputs['trademarkFile'] = '';
        this.inputs['trademarkFilename'] = '';
        this.inputs['trademarkFilesize'] = '';
      }
    },
    setDropZoneActive() {
      this.dropZoneActive = true;
      clearTimeout(this.inActiveTimeout);
    },
    setDropZoneInactive() {
      const ctx = this;
      this.inActiveTimeout = setTimeout(() => {
        ctx.dropZoneActive = false
      }, 50);
    },
    onDrop(e) {
      this.onChangeFile({target: { files: e.dataTransfer.files }});
      this.setDropZoneInactive();
    },
    ...mapMutations([
      'updateGlobalInputs',
      'stopLoading',
      'setGlobalCategories',
      'setGlobalId',
      'setGlobalEmail',
    ]),
    ...mapActions([
      'submitData'
    ])
  },
  watch: {
    nextFlag() {
      this.handleSubmit();
    }
  }
}
</script>
