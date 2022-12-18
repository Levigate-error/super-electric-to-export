"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const SpecTable_1 = require("./components/SpecTable/SpecTable");
const AddProduct_1 = require("../Specification/components/AddProduct/AddProduct");
const Spinner_1 = require("../../../../ui/Spinner");
const classnames_1 = require("classnames");
const specSpinnerStyle = {
    position: 'absolute',
    zIndex: 2,
    left: 'calc(50% - 32px)',
    top: 'calc(50% - 32px)',
};
function Specification({ sections = [], specification, setSections, projectId, updateSpec, isLoading, }) {
    return (React.createElement("div", { className: classnames_1.default('spec-table-wrapper', 'mt-3 mt-md-0') },
        isLoading && React.createElement(Spinner_1.default, { style: specSpinnerStyle }),
        React.createElement("div", { className: classnames_1.default('spec-tables-wrapper', {
                'spec-table-wrapper-loading': isLoading,
            }) }, sections.map(section => (React.createElement("div", { id: `section-${section.id}`, className: isLoading ? 'loading-section' : 'loaded-section', key: section.id || 'fake_section' },
            React.createElement(SpecTable_1.default, { section: section, sections: sections, specification: specification, setSections: setSections, projectId: projectId, updateSpec: updateSpec, isLoading: isLoading }),
            React.createElement(AddProduct_1.default, { projectId: projectId, section: section, updateSpec: updateSpec, specificationId: specification.id })))))));
}
exports.Specification = Specification;
exports.default = Specification;
