module.exports = {
    root: true,
    env: {
        node: true,
        es6: true
    },
    extends: [
        'eslint:recommended',
        'plugin:@wordpress/eslint-plugin/recommended'
    ],
    parserOptions: {
        ecmaVersion: 2021
    },
    rules: {
        // Add your custom rules here
    },
    settings: {
        // Add your path aliases here
        'import/resolver': {
            alias: {
                map: [
                    ['@components', './block-editor/components'],
                    ['@icons', './block-editor/icons'],
                    ['@utils', './block-editor/utils'],
                    ['@services', './block-editor/services'],
                    ['@scss', './block-editor/scss'],
                ],
                extensions: ['.js', '.jsx', '.json']
            }
        }
    }
};