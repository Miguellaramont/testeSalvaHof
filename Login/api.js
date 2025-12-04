// api.js
/*console.log();

const url = 'http://temp.api.salvahof.neuroon.top/api/usuarios/v1/login.php';

const botao = document.getElementById('button-login');
const inputEmail = document.getElementById('email');
const inputSenha = document.getElementById('senha');

async function login(email, senha) {
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email, senha })
    });

    if (!response.ok) {
      throw new Error('Erro na requisição: ' + response.status);
    }

    const data = await response.json();
    console.log('Dados do usuário:', data);
    // aqui você decide o que fazer: redirecionar, guardar em sessãoStorage etc.
    return data;
  } catch (error) {
    console.error('Erro ao fazer login:', error);
  }
}

// função que será o listener do clique
botao.addEventListener('click', async (event) => {
  event.preventDefault(); // impede o submit padrão do form

  const email = inputEmail.value;
  const senha = inputSenha.value;

  // validação simples
  if (!email || !senha) {
    alert('Preencha email e senha.');
    return;
  }

  const user = await login(email, senha);
  console.log('Retorno da API:', user);
});
*/