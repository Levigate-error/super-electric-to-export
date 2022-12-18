import React from 'react';
import Loyalty from "./Loyalty";
import ReactDOMServer from 'react-dom/server';

let { data } = context;
const html = ReactDOMServer.renderToString(<Loyalty store={data} />);
dispatch(html);
