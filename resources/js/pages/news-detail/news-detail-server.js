import React from 'react';
import NewsDetail from './NewsDetail';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<NewsDetail store={data} />);
dispatch(html);
