import React from 'react';
import TestDetail from './TestDetail';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<TestDetail store={data} />);
dispatch(html);
