<?php

const ALLOWED_FORMATS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
const OUTPUT_FORMATS = ['jpg', 'png', 'webp'];
const DEFAULT_FORMAT = 'jpg';

const OUTPUT_DIR = './cache';
const UPLOAD_DIR = './uploads';

const MAX_FILE_SIZE_MB = 500;
const KEEP_ORIGINAL = false;
const KEEP_COMPRESSED = false;

const DEFAULT_MAX_WIDTH = 1920;
const DEFAULT_MAX_HEIGHT = 1920;