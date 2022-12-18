import React from 'react';
import ReactDOM from 'react-dom';
import VideoList from './VideoList';

const data = window.__INITIAL_STORE__ || [];
ReactDOM.hydrate(<VideoList store={data} />, document.getElementById('app'));
