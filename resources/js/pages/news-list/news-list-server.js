import React from 'react';
import NewsList from './NewsList';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<NewsList store={data} />);
dispatch(html);
