<template>
  <div>

    <p>Video name : {{ this.source }}</p>
    <video-player class="video-js vjs-default-skin " data-setup='{"fluid": true}'
      :source="source"
      :src="src"
      controls
      :loop="true"
      :volume="0.6"
      :autoplay="false"
    />

  </div>
</template>

<script>
  import { VideoPlayer } from '@videojs-player/vue'
  import 'video.js/dist/video-js.css'


export default {
  name: 'VideoExample',
  components: {
    VideoPlayer,
  },
  props: ['source'],
  data() {
    return {
      src: ''
    }
  },
  computed:{
    src(){
      return '/assets/videos/' + this.source + '.mp4'
    }
  }
};
</script>
<style scoped>
</style>