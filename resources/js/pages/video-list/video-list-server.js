import React from 'react';
import VideoList from './VideoList';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<VideoList store={data} />);
dispatch(html);
