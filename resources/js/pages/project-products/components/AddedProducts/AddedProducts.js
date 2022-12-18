"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const api_1 = require("./api");
const Divisions_1 = require("./components/Divisions");
const Products_1 = require("./components/Products");
class AddedProducts extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            isLoading: false,
            selectedDivision: null,
            divisions: [],
        };
        this.fetchDivisions = category => {
            const { projectId } = this.props;
            this.setState({ isLoading: true, selectedDivision: null });
            api_1.fetchCategoryDivisions({
                project_id: projectId,
                category_id: category.id,
            }).then(response => {
                this.setState({ divisions: response, isLoading: false });
            });
        };
        this.handleSelectDivision = division => {
            if (division.product_amount === 0) {
                const baseUrl = window.location.origin;
                document.location.href = baseUrl + `/catalog?division_id=${division.id}`;
            }
            else {
                this.setState({ selectedDivision: division });
            }
        };
        this.handleBackToDivision = () => __awaiter(this, void 0, void 0, function* () {
            const { category } = this.props;
            yield this.fetchDivisions(category);
            this.setState({ selectedDivision: null });
        });
    }
    componentDidMount() {
        const { category } = this.props;
        this.fetchDivisions(category);
    }
    render() {
        const { category, projectId } = this.props;
        const { selectedDivision, divisions, isLoading } = this.state;
        const divisionsIsVisible = !selectedDivision;
        return (React.createElement(React.Fragment, null,
            divisionsIsVisible && (React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-12  mt-sm-3 mt-md-0" },
                    React.createElement("h3", null, category.name)))),
            React.createElement("div", { className: "products-divisions-wrapper mt-3" },
                !isLoading && divisionsIsVisible && (React.createElement("div", { className: "added-products-wrapper" },
                    React.createElement(Divisions_1.default, { categoryId: category.id, divisions: divisions, selectAction: this.handleSelectDivision }))),
                !isLoading && !divisionsIsVisible && (React.createElement("div", { className: "added-products-wrapper" },
                    React.createElement(Products_1.default, { projectId: projectId, category: category, division: selectedDivision, back: this.handleBackToDivision }))))));
    }
}
exports.AddedProducts = AddedProducts;
exports.default = AddedProducts;
