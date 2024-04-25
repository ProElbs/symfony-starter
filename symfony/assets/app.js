import './bootstrap.js';
import './styles/app.css';

// assets/app.js
import { registerReactControllerComponents } from '@symfony/ux-react';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));
