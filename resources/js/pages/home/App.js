import React from 'react';
import ReactDOM from 'react-dom';
import Home from './Home';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<Home store={data} />, document.getElementById('app'));
