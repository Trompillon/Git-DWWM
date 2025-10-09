/**
 * Returns the letter position in the alphabet
 *
 * @param {string} letter - A letter to transform
 * @return {number} number - The position in the alphabet
 */
function letterToNumber(letter) {
  return parseInt(letter, 36) - 9;
}

const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

/**
 * Returns if the letter is in the alphabet
 *
 * @param {string} letter - A letter to transform
 * @return {boolean} true if the letter is present in the alphabet
 */
function isLetterInAlphabet(letter) {
  return alphabet.includes(letter.toUpperCase());
}

/**
 * Returns the letter position in the alphabet
 *
 * @param {string} letter - A letter to transform
 * @return {number} number - The position in the alphabet
 */
function letterToNumber(letter) {
  if (!isLetterInAlphabet(letter)) {
    return false;
  }

  return alphabet.indexOf(letter.toUpperCase()) + 1;
}

/**
 * Returns the shifted letter of an offset in the alphabet
 *
 * @param {string} letter
 * @param {number} offset
 * @return {number} The shifted letter
 */
function shiftLetter(letter, offset) {
  if (!isLetterInAlphabet(letter)) {
    return letter;
  }

  return numberToLetter(letterToNumber(letter) + offset);
}

/**
 * Returns the message encoded with the Caesar cipher, the offset depends on key
 *
 * @param {string} message
 * @param {number} key
 * @param {boolean} isDecoding - true to decode instead of encode
 * @return {string} The encoded message
 */
function encodeCaesar(message, key, isDecoding) {
  return message
    .split("")
    .map(function(letter) {
      if (!isLetterInAlphabet(letter)) {
        return letter;
      }

      return shiftLetter(letter, isDecoding ? -key : key);
    })
    .join("");
}

