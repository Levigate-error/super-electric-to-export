import React from 'react';
import ReactDOM from 'react-dom';
import TestDetail from './TestDetail';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<TestDetail store={data} />, document.getElementById('app'));
