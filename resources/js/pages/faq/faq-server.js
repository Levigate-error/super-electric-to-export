import React from 'react';
import FAQ from './FAQ';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<FAQ store={data} />);
dispatch(html);
