import styled, { css } from 'styled-components';

const Wrapper = styled.div`
  display: flex;
  background: #F0F9FE;
`;
const Box = styled.div`
  &:first-of-type {
    width: 46%;
    padding-left: 104px;
  }
  &:last-of-type {
    width: 54%;
  }
  @media (max-width: 1024px) {
    &:first-of-type {
      width: 100%;
      padding: 50px 30px;
    }
    &:last-of-type {
      display: none;
    }
  }
`;
const Text = styled.div<{big?: boolean}>`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  font-size: 25.4247px;
  line-height: 30px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  font-feature-settings: 'pnum' on, 'lnum' on;
  color: #475054;
  max-width: 427px;
  margin-bottom: 67px;

  ${(props) => props.big && css`
    font-size: 60px;
    line-height: 70px;
    letter-spacing: 0.05em;
    max-width: 482px;
    margin-bottom: 35px;
  `};
  @media (max-width: 800px) {
    font-size: 18px;
    line-height: 22px;
    ${(props) => props.big && css`
    font-size: 30px;
    line-height: 40px;
  `};
  }
`;
const Button = styled.a`
  background: #E60004;
  border-radius: 3px;
  display: flex;
  justify-content: center;
  text-align: center;
  align-items: center;
  padding: 23px 80.5px;
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 21px;
  color: #FFFFFF;
    width: fit-content;
`;
const Img = styled.img`
  width: 100%;
  height: 100%;
  object-fit: cover;
`;

export default {
  Wrapper,
  Box,
  Text,
  Button,
  Img,
};
