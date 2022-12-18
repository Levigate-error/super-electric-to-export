import React from 'react';
import ReactDOM from 'react-dom';
import FAQ from './FAQ';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<FAQ store={data} />, document.getElementById('app'));
