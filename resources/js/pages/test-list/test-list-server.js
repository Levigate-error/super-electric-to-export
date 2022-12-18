import React from 'react';
import TestList from './TestList';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<TestList store={data} />);
dispatch(html);
