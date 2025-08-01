<?php

return [
  'swagger' => [
      'ui' => [
          'route' => 'swagger', // Путь для UI Swagger документации
          'version' => '1.0.0',
          'title' => 'API для справочника организаций',
          'description' => 'API для работы с организациями, зданиями и видами деятельности.',
      ],
  ],
  'paths' => [
      'docs' => storage_path('api-docs'), // Папка для сохранения документации
  ]
];
