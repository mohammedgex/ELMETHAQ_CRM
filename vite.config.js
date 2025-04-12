import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import rtlcss from "rtlcss";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/adminlte.css",
                "resources/css/adminite-rtl.css",
                "resources/css/admin_custom.css",
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/css/app.css",
            ],
            refresh: true,
        }),
        {
            name: "rtlcss",
            transform: (code, id) => {
                if (id.includes("adminlte-rtl.css")) {
                    return rtlcss.process(code);
                }
            },
        },
    ],
});
