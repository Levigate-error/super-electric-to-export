import styled from 'styled-components';

const Wrapper = styled.div`
  background: #F0F9FE;
  padding: 211px 0 143px 100px;
  @media (max-width: 1024px) {
    padding: 50px 30px;
  }
`;
const Box = styled.div`
  display: flex;
  @media (max-width: 1024px) {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 50px;
  }
  @media (max-width: 800px) {
    display: flex;
    flex-direction: column;
  }
`;
const Container = styled.div`
  max-width: 1440px;
  margin: 0 auto;
`;
const Title = styled.div`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  font-size: 60px;
  line-height: 70px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  font-feature-settings: 'pnum' on, 'lnum' on;
  color: #475054;
  @media (max-width: 800px) {
    font-size: 30px;
    line-height: 40px;
  }
`;
const SubTitle = styled.div`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  font-size: 21px;
  line-height: 25px;
  font-feature-settings: 'pnum' on, 'lnum' on;
  color: #475054;
  margin-bottom: 80px;
  @media (max-width: 800px) {
    font-size: 18px;
    line-height: 23px;
  }
`;
const Item = styled.div`
  display: flex;
  max-width: 355px;
  flex-direction: column;
  margin-right: 86px;
  height: 390px;
  &:nth-of-type(2) {
    margin-right: 97px;
  }
  &:last-of-type {
    margin-right: 0;
  }
  @media (max-width: 1024px) {
    margin-right: 0;
    margin-bottom: 25px;
    &:nth-of-type(2) {
      margin-right:0;
    }
    &:last-of-type {
      margin-bottom: 0;
    }
  }
  @media (max-width: 800px) {
    height: max-content;
  }
`;
const Text = styled.div`
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 700;
  font-size: 24px;
  line-height: 34px;
  font-feature-settings: 'pnum' on, 'lnum' on;
  color: #475054;
  @media (max-width: 800px) {
    font-size: 18px;
    line-height: 23px;
  }
`;
const Img = styled.img`
  width: 170px;
  height: 170px;
  margin-bottom: 22px;
`;
const Button = styled.a`
    display: flex;
    justify-content: center;
    align-items: center;
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 700;
  font-size: 20px;
  line-height: 23px;
  text-align: center;
  margin-top: auto;
  color: #E60004;
  background: #FFFFFF;
  height: 57px;
  width: 100%;
  border: 1px solid #E60004;
  @media (max-width: 800px) {
    margin-top: 25px;
  }
`;

export default {
  Wrapper,
  Box,
  Title,
  SubTitle,
  Container,
  Item,
  Text,
  Img,
  Button,
};
