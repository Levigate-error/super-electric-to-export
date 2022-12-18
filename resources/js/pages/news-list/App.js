import React from 'react';
import ReactDOM from 'react-dom';
import NewsList from './NewsList';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<NewsList store={data} />, document.getElementById('app'));
