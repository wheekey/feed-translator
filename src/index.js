import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import './index.css';
import '../node_modules/bootstrap/dist/css/bootstrap.min.css';
require('dotenv').config({ path: '../.env' });

ReactDOM.render(
  <App />,
  document.getElementById('root')
);
