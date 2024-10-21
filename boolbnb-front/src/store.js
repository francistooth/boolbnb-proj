import { reactive } from "vue";

export const store = reactive({
  // http://localhost:8000/api/ url per Ennio
  // http://localhost:8001/api/ url per Loris
  apiUrl: "http://127.0.0.1:8000/api/",
});
