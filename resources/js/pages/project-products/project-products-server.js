import React from "react";
import ProjectProducts from "./ProjectProducts";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<ProjectProducts store={data} />);
dispatch(html);
