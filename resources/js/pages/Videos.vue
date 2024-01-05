<template>
    <!-- loop all videos and pass props into components -->
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="input-group mb-3">
        <div class="col-md-8">
          <input
            type="text"
            class="form-control"
            v-model="videoSrc"
            placeholder="Please enter video name"
          />
        </div>
        <div class="col-md-4">
          <button class="btn btn-success" @click="submit">change src</button>
        </div>
        <!-- <router-link to="/videos" class="m-3"> X CLEAR INPUT</router-link> -->
      </div>

      <VideoTag class="my-3" :source="videoSrc" v-show="isSubmit" />

      <div v-if="videoSrc == ''">
        <VideoTag
          class="my-3"
          v-for="vid in videos"
          :key="vid.id"
          :source="vid.source"
          v-show="!isSubmit"
        />
      </div>
    </div>
    <div class="col-md-2"></div>
</template>

<script>
import VideoTag from "../components/VideoTag.vue";

export default {
  name: "VideoExample",
  components: {
    VideoTag,
  },
  data() {
    return {
      isEmptySearch: true,
      isSubmit: false,
      videoSrc: "",
      videos: [
        {
          source: "samplec",
        },
         {
          source: "sampleb",
        },
        {
          source: "samplea",
        },
      ],
    };
  },
  methods: {
    submit() {
      alert("changed");
      this.isSubmit = true;
    },
  },
};
</script>