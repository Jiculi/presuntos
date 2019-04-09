const path = require('path');
var HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    entry:  { actores: path.resolve(__dirname, 'src/actores.js'),
              juicios: path.resolve(__dirname, 'src/altaJuicio.js'),
              recursos: path.resolve(__dirname, 'src/altaRecurso.js'),
              amparos: path.resolve(__dirname, 'src/altaAmparo.js')
            },
    output: {
        path: __dirname,
        publicPath: '/',
        filename: 'dist/[name].js'
    },
    module: {
        rules:[
            {
                test:/\.css$/,
                use:['style-loader','css-loader']
            }
        ],
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/
            },

        ]

    },
    plugins: [new HtmlWebpackPlugin({
        template: './actores.php'
    })]
};
