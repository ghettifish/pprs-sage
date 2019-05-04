module.exports = {
  'extends': [
    'stylelint-config-standard',
    'stylelint-config-prettier',
  ],
  'rules': {
    'no-empty-source': null,
    'string-quotes': 'double',
    'block-no-empty': true,
    'no-descending-specificity': null,
    'at-rule-no-unknown': [
      true,
      {
        'ignoreAtRules': [
          'extend',
          'at-root',
          'debug',
          'warn',
          'error',
          'if',
          'else',
          'for',
          'each',
          'while',
          'mixin',
          'include',
          'content',
          'return',
          'function',
          'tailwind',
          'apply',
          'responsive',
          'variants',
          'screen',
        ],
      },
    ],
  },
};
