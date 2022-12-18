import styled, { css } from 'styled-components';

const Accordion = styled.div`
  margin-bottom: 8px;
  max-width: 689px;
  width: 100%;
`;
const Head = styled.div<{active?: boolean}>`
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  border-radius: 60px;
  background-color: #ffffff;
  padding: 20px 18px 20px 40px;
  text-align: left;
  font-size: 24px;
  cursor: pointer;
  width: 100%;
  line-height: 28px;
  user-select: none;
  ${(props) => props.active && css`
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
  `};
  @media (max-width: 800px) {
    font-size: 20px;
    line-height: 28px;
}
`;
const Icon = styled.img<{active?: boolean}>`
  transition: all 0.3s ease-in;
  ${(props) => props.active && css`
    transform: rotate(-45deg);
  `}
`;
const Content = styled.div<{active?: boolean}>`
  padding: 0 28px;
  background-color: #ffffff;
  overflow: hidden;
  border-bottom-left-radius: 3px;
  border-bottom-right-radius: 3px;
  margin-top: -2px;
  margin-bottom: 6px;
  max-width: 689px;
  display: none;
  transition: max-height 0.4s ease-in-out;
  font-weight: 400;
  font-size: 24px;
  line-height: 28px;
  color: #000000;
  ${(props) => props.active && css`
    border-bottom-left-radius: 60px;
    border-bottom-right-radius: 60px;
    display: block;
  `}
  p {
    margin-bottom: 1em;
    display: block;

    @media (max-width: 800px) {
      font-size: 20px;
      line-height: 28px;
    }
`;

export default {
  Accordion,
  Head,
  Icon,
  Content,
};
