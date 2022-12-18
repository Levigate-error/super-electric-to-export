import styled, { css } from 'styled-components';

const Wrapper = styled.div`
  background: #F0F9FE;
  height: 910px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  z-index: -3;
  &:after {
    content: "";
    position: absolute;
    display: block;
    z-index: -2;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url("/img/intro-back.png");
    background-position-y: 25%;
    width: 100%;
    height: 100%;
  }
  @media (max-width: 1024px) {
    height: 680px;
  }
`;

const Text = styled.div<{small?: boolean, medium?: boolean}>`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 700;
  font-size: 83.4711px;
  line-height: 89px;
  text-align: center;
  letter-spacing: 0.05em;
  max-width: 505px;
  margin: 0 auto;
  color: #475054;
  ${(props) => props.medium && css`
    font-size: 24px;
    max-width: 510px;
    margin-top: 20px;
    margin-bottom: 17px;
    line-height: 25px;
    font-feature-settings: 'pnum' on, 'lnum' on;
  `};
  ${(props) => props.small && css`
    font-weight: 500;
    font-size: 20px;
    line-height: 25px;
    font-feature-settings: 'pnum' on, 'lnum' on;
    color: #434B6F;
  `};
  @media (max-width: 1024px) {
    font-size: 63px;
    line-height: 68px;
    ${(props) => props.medium && css`
      font-size: 22px;
      line-height: 25px;
  `};
    ${(props) => props.small && css`
      font-size: 18px;
      line-height: 23px;
  `};
  }
`;
const Box = styled.div`
  border-radius: 50%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  max-width: 1200px;
  width: 100%;
  height: 100%;
  z-index: 5;
  &:after {
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    background-image: url("/img/Ellipse2.png");
    background-repeat: no-repeat;
    background-position-y: center;
    background-size: cover;
    border-radius: 50%;
    top: 0;
    left: 0;
  }
  @media (max-width: 1024px) {
    background-size: contain;
  }
`;

export default {
  Wrapper,
  Text,
  Box,
};
