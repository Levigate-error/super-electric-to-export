import React from "react";
import Product from "./Product";
import ReactDOMServer from "react-dom/server";

let { product } = context;
const html = ReactDOMServer.renderToString(<Product store={product} />);
dispatch(html);
