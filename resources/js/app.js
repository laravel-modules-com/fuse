import './bootstrap';
import 'flatpickr';

import * as FilePond from 'filepond';
window.FilePond = FilePond;

import Prism from 'prismjs';
import 'prismjs/themes/prism-tomorrow.css'; // see other themes in the prism docs
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-css';
import 'prismjs/components/prism-javascript';
Prism.highlightAll()
