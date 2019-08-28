const {resolve} = require('path');

let config = {
    module: {}
};

let gutenberg = Object.assign({}, config, {
    name: "gutenberg",
    entry: "./src/js/gutenberg",
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: [
                    /node_modules/,
                    /dist/,
                    /vendor/
                ],
                use: {
                    loader: "babel-loader"
                }
            }, {
                test: /\.(ts|tsx)$/,
                exclude: [
                    /node_modules/
                ],
                use: [
                    {
                        loader: "ts-loader"
                    }
                ]
            }
        ]
    },
    output: {
        filename: "hp_gutenberg.js",
        path: resolve(__dirname, "wordpress/wp-content/plugins/HidePost/dist/")
    },
    resolve: {
        extensions: [".js", ".jsx", ".ts", ".tsx"]
    }
});

module.exports = [
    gutenberg
];
