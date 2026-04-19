export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],

  safelist: [
    "status-primary",
    "status-secondary",
    "status-accent",
    "status-neutral",
    "status-info",
    "status-success",
    "status-warning",
    "status-error",
  ],

  plugins: [
    require("daisyui"),
  ],
};