<?php

// infix to postfix with parameters


class InfixToPostfix
{
    public $mathInfix;
    public $stack;

// принимаем строку примера
    public function setMathInfix(string $mathInfix)
    {
        $this->mathInfix = $mathInfix;
    }

    public function __construct()
    {
        $this->stack = new SplStack();
    }

//основная функция
    public function convert()
    {
        $mathPostfix = "";
//делим пример на массив
        $charArr = preg_split('//', $this->mathInfix, -1, PREG_SPLIT_NO_EMPTY);

        $n = count($charArr);
        for ($i = 0; $i < $n; $i++) {
            $ch = $charArr[$i];
//добавляем число из нескольких цифр до тех пор, пока не придет пробел или оператор
            if (is_numeric($ch)) {
                while (is_numeric($charArr[$i])) {
                    $mathPostfix .= $charArr[$i++];
                }
                $i--;
// добавляем пробел в качестве разделителя
                $mathPostfix .= ' ';
// параметр заносим сразу с пробелом
            } elseif (parameter::isParameter($ch)) {
                $mathPostfix .= $ch . ' ';
//если пришла скобка
            } elseif ($ch == '(') {
// пушим её в стек
                $this->stack->push($ch);
//если пришла правая скобка
            } elseif ($ch == ')') {
// достаем из стека операторы, пока не уткнемся в левую скобку
                while ($this->stack->top() != '(') {
                    $mathPostfix .= $this->stack->pop() . ' ';
                }
// и удаляем левую скобку
                $this->stack->pop();
//а если оператор
            } elseif (toolFunc::isOperator($ch)) {
// то проверяем на приоритет операции и добавляем в постфикс сперва с бОльшим
                while (!$this->stack->isEmpty() &&
                    toolFunc::priority($this->stack->top()) >= toolFunc::priority($ch)) {
                    $mathPostfix .= $this->stack->pop() . ' ';
                }
//а если нет, то пушим в стек
                $this->stack->push($ch);
            }
        }
// после окончания проверки примера в стеке еще есть операторы. Вытаскиваем их
        while (!$this->stack->isEmpty()) {
            $mathPostfix .= $this->stack->pop() . ' ';
        }
//возвращаем готовый пример в постфиксной форме
        return $mathPostfix;
    }

}

class MathParse
{
    public $stack;
    public $math;


    public function __construct(string $math)
    {
        $this->stack = new SplStack();
        $this->math = $math;
    }


    function doMathParse()
    {
//разделяем на массив
        $mathArray = preg_split('//', $this->math, -1, PREG_SPLIT_NO_EMPTY);

        $n = count($mathArray);
        for ($i = 0; $i < $n; $i++) {

            $ch = $mathArray[$i]; //один символ

//если число
            if (is_numeric($ch)) {
                $number = '';

// пробегаем по всему числу, пока не наткнемся на пробел
                while (is_numeric($mathArray[$i])) {
                    $number .= $mathArray[$i++];
                }
//пушим в стек
                $this->stack->push((int)$number);

                $i--;


            } //если параметр, сразу пушим в стек
            elseif (parameter::isParameter($ch)) {
                $this->stack->push($ch);
            } //если оператор
            elseif (toolFunc::isOperator($ch)) {

//достаем последние 2 числа
                $num2 = $this->stack->pop();
                $num1 = $this->stack->pop();

//и что-то с ними делаем
                switch ($ch) {
                    case '+':
                        if (!is_int($num1) || !is_int($num2)) {
                            $res = "($num1+$num2)";
                        } else {
                            $res = $num1 + $num2;
                        }
                        break;
                    case '-':
                        if (!is_int($num1) || !is_int($num2)) {
                            $res = "($num1-$num2)";
                        } else {
                            $res = $num1 - $num2;
                        }
                        break;
                    case '*':
                        if (!is_int($num1) || !is_int($num2)) {
                            $res = "($num1*$num2)";
                        } else {
                            $res = $num1 * $num2;
                        }
                        break;
                    case '/':
                        if (!is_int($num1) || !is_int($num2)) {
                            $res = "($num1/$num2)";
                        } else {
                            $res = $num1 / $num2;
                        }
                        break;
                    case '^':
                        if (!is_int($num1) || !is_int($num2)) {
                            $res = "($num1**$num2)";
                        } else {
                            $res = $num1 ** $num2;
                        }
                        break;
                    default:
                        $res = 0;
                }
//результат пушим в стек
                $this->stack->push($res);
            }
        }

//отдаем получившийся результат
        return $this->stack->pop();
    }


}

//класс для пары общих функций
class toolFunc
{

    public static function isOperator($ch)
    {
        $operators = ['^', '*', '/', '+', '-'];
        return in_array($ch, $operators);
    }

    public static function priority($operator)
    {
        switch ($operator) {
            case '^' :
                return 3;
            case '*' :
            case '/' :
                return 2;
            case '+' :
            case '-' :
                return 1;
        }
        return 0;
    }

}

// класс параметров
class parameter
{
    public static function isParameter($ch)
    {
        $parameters = ['x', 'y', 'z'];
        return in_array($ch, $parameters);
    }
}

echo 'infix:   ' . $infix = '(x + 42) ^ 2 + 7 * y - z' . PHP_EOL;

$infixToPostfix = new InfixToPostfix();

$infixToPostfix->setMathInfix($infix);

echo 'postfix: ' . $postfix = $infixToPostfix->convert() . PHP_EOL;

$mathParse = new MathParse($postfix);
echo 'result:  ' . $mathParse->doMathParse();