import React from "react"
import Promo from "./Promo";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<Promo store={data}/>);
dispatch(html);
