function validarSenha() {
  var senha = document.getElementById("senha").value;
  var confirmarSenha = document.getElementById("confirmar_senha").value;

  if (senha != confirmarSenha) {
    alert("As senhas não são iguais.");
    return false;
  }
  return true;
}