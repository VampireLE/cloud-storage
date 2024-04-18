<?php

// $subject = 'https://example.com/cloud_storage/storage/share/1';
// $pattern = '/cloud_storage\/storage\/share\/[A-Za-z0-9]+/';

// preg_match($pattern, $subject, $matches);
// echo $matches[0];

echo $result = preg_match('/cloud_storage\/storage\/share\/([A-Za-z0-9]+)/', 'https://example.com/cloud_storage/storage/share/12345', $matches) ? $matches[0] : '';
