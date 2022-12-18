import React from 'react';
import ReactDOM from 'react-dom';
import NewsDetail from './NewsDetail';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<NewsDetail store={data} />, document.getElementById('app'));
