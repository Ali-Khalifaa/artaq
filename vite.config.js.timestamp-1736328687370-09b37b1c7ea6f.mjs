// vite.config.js
import { defineConfig, loadEnv } from "file:///var/www/html/LeeTaxi/node_modules/vite/dist/node/index.js";
import laravel from "file:///var/www/html/LeeTaxi/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///var/www/html/LeeTaxi/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var vite_config_default = defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd());
  return {
    plugins: [
      laravel({
        input: [
          "resources/css/app.css",
          "resources/js/app.js",
          "resources/js/single-components.js",
        ],
        refresh: true
      }),
      vue({
        template: {
          transformAssetUrls: {
            base: null,
            includeAbsolute: false
          }
        }
      })
    ],
    resolve: {
      alias: {
        vue: "vue/dist/vue.esm-bundler.js"
      }
    },
    server: {
      https: false,
      host: env.VITE_DOMAIN
    }
  };
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvdmFyL3d3dy9odG1sL0xlZVRheGlcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIi92YXIvd3d3L2h0bWwvTGVlVGF4aS92aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vdmFyL3d3dy9odG1sL0xlZVRheGkvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcsIGxvYWRFbnYgfSBmcm9tIFwidml0ZVwiO1xuaW1wb3J0IGxhcmF2ZWwgZnJvbSBcImxhcmF2ZWwtdml0ZS1wbHVnaW5cIjtcbmltcG9ydCB2dWUgZnJvbSBcIkB2aXRlanMvcGx1Z2luLXZ1ZVwiO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoKHsgbW9kZSB9KSA9PiB7XG4gICAgY29uc3QgZW52ID0gbG9hZEVudihtb2RlLCBwcm9jZXNzLmN3ZCgpKTtcblxuICAgIHJldHVybiB7XG4gICAgICAgIHBsdWdpbnM6IFtcbiAgICAgICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgICAgIFwicmVzb3VyY2VzL2Nzcy9hcHAuY3NzXCIsXG4gICAgICAgICAgICAgICAgICAgIFwicmVzb3VyY2VzL2pzL2FwcC5qc1wiLCBcbiAgICAgICAgICAgICAgICAgICAgXCJyZXNvdXJjZXMvanMvc2luZ2xlLWNvbXBvbmVudHMuanNcIixcbiAgICAgICAgICAgICAgICAgICAgXCJyZXNvdXJjZXMvanMvcmVzdGF1cmFudC5qc1wiLFxuICAgICAgICAgICAgICAgICAgICBcInJlc291cmNlcy9qcy9zaG93cm9vbS5qc1wiLFxuICAgICAgICAgICAgICAgIF0sXG4gICAgICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgdnVlKHtcbiAgICAgICAgICAgICAgICB0ZW1wbGF0ZToge1xuICAgICAgICAgICAgICAgICAgICB0cmFuc2Zvcm1Bc3NldFVybHM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGJhc2U6IG51bGwsXG4gICAgICAgICAgICAgICAgICAgICAgICBpbmNsdWRlQWJzb2x1dGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB9KSxcbiAgICAgICAgXSxcbiAgICAgICAgcmVzb2x2ZToge1xuICAgICAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgICAgICB2dWU6IFwidnVlL2Rpc3QvdnVlLmVzbS1idW5kbGVyLmpzXCIsXG4gICAgICAgICAgICB9LFxuICAgICAgICB9LFxuICAgICAgICBzZXJ2ZXI6IHtcbiAgICAgICAgICAgIGh0dHBzOiBmYWxzZSxcbiAgICAgICAgICAgIGhvc3Q6IGVudi5WSVRFX0RPTUFJTixcbiAgICAgICAgfSxcbiAgICB9O1xufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQWlQLFNBQVMsY0FBYyxlQUFlO0FBQ3ZSLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFFaEIsSUFBTyxzQkFBUSxhQUFhLENBQUMsRUFBRSxLQUFLLE1BQU07QUFDdEMsUUFBTSxNQUFNLFFBQVEsTUFBTSxRQUFRLElBQUksQ0FBQztBQUV2QyxTQUFPO0FBQUEsSUFDSCxTQUFTO0FBQUEsTUFDTCxRQUFRO0FBQUEsUUFDSixPQUFPO0FBQUEsVUFDSDtBQUFBLFVBQ0E7QUFBQSxVQUNBO0FBQUEsVUFDQTtBQUFBLFVBQ0E7QUFBQSxRQUNKO0FBQUEsUUFDQSxTQUFTO0FBQUEsTUFDYixDQUFDO0FBQUEsTUFDRCxJQUFJO0FBQUEsUUFDQSxVQUFVO0FBQUEsVUFDTixvQkFBb0I7QUFBQSxZQUNoQixNQUFNO0FBQUEsWUFDTixpQkFBaUI7QUFBQSxVQUNyQjtBQUFBLFFBQ0o7QUFBQSxNQUNKLENBQUM7QUFBQSxJQUNMO0FBQUEsSUFDQSxTQUFTO0FBQUEsTUFDTCxPQUFPO0FBQUEsUUFDSCxLQUFLO0FBQUEsTUFDVDtBQUFBLElBQ0o7QUFBQSxJQUNBLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQSxNQUNQLE1BQU0sSUFBSTtBQUFBLElBQ2Q7QUFBQSxFQUNKO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
