import React from "react";
import Catalog from "./Catalog";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<Catalog store={data} />);
dispatch(html);
