import React from "react";
import ProjectsList from "./ProjectsList";
import ReactDOMServer from "react-dom/server";

let { data } = context;
const html = ReactDOMServer.renderToString(<ProjectsList store={data} />);
dispatch(html);
