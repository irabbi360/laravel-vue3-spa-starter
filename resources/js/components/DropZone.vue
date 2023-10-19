<template>
    <div>
        <div ref="dropRef" class="dropzone custom-dropzone"></div>
        <div class="dropzone preview-container"></div>
    </div>
</template>

<script>

import { ref, onMounted, defineComponent } from 'vue'
import { Dropzone } from 'dropzone'
import { useStore } from 'vuex'

export default defineComponent({
    name: 'Dropzone',
    props:['paramName'],
    setup(props) {
        //using vuex
        const store = useStore()

        //getting the div container
        const dropRef = ref(null)

        //creating html custom preview for uploading files
        const customPreview = `
        <div class="d-flex flex-wrap dz-preview dz-processing dz-image-preview dz-complete mt-3">
          <div class="dz-image">
            <img data-dz-thumbnail>
          </div>
          <div class="dz-details">
            <div class="dz-size"><span data-dz-size></span></div>
              <div class="dz-filename"><span data-dz-name></span></div>
            </div>
            <div class="dz-progress">
              <span class="dz-upload" data-dz-uploadprogress></span>
            </div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <div class="dz-success-mark">
                <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: green;"></i>
            </div>
            <div class="dz-error-mark">
                <i class="bi bi-exclamation-circle-fill" style="font-size: 2rem; color: red;"></i>
          </div>
        </div>
      `

        onMounted(() => {
            // Configuring Dropzone and Adding to div element
            if(dropRef.value !== null) {
                new Dropzone(dropRef.value, {
                    url: 'https://backendUrl/uploadFile/',//backend url
                    method: 'POST',
                    headers:{Authorization: 'Bearer ' + store.state.token,}, // getting API access token form vuex store to be sent with request
                    maxFiles: 1,
                    paramName:props.paramName, // input name
                    acceptedFiles:".jpg,.png,.jpeg,.webp, .gif", // accepted files
                    previewTemplate: customPreview,
                    previewsContainer: dropRef.value.parentElement.querySelector('.preview-container'),
                })
                // customizing the input field of dropzone
                if(dropRef.value.querySelector('.dz-default')) {
                    dropRef.value.querySelector('.dz-default').innerHTML = `
              <div style="display: flex; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                  <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                </svg>
              </div>
              <p style="text-align: center; margin: 0;">Drag and drop thumbnail to upload</p>
            `
                }
            }
        })

        return {
            dropRef
        }
    }
})
</script>

<style scoped>
.custom-dropzone {
    border-style: dashed;
    border-width: 1px;
    padding: 20px;
    color:rgb(114, 114, 114);
    cursor: pointer;
}

</style>
