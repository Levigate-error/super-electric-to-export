import React from 'react';
import Home from './Home';
import ReactDOMServer from 'react-dom/server';

const { data } = context;
const html = ReactDOMServer.renderToString(<Home store={data} />);
dispatch(html);
