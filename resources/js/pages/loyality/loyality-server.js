import React from "react";
import Loyality from "./Loyality";
//import Loyalty from "./Loyalty";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<Loyality store={data} />);
dispatch(html);
