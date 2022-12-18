import React from 'react';
import ReactDOM from 'react-dom';
import TestList from './TestList';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<TestList store={data} />, document.getElementById('app'));
