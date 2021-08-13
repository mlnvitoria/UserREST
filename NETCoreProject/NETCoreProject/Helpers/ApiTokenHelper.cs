using System;
using System.Text;

namespace NETCoreProject.Helpers
{
    public class ApiTokenHelper
    {
        public string GenerateToken()
        {
            var builder = new StringBuilder();
            var random = new Random();
            char ch;
            for (int i = 0; i < 32; i++)
            {
                ch = Convert.ToChar(Convert.ToInt32(Math.Floor(26 * random.NextDouble() + 65)));
                builder.Append(ch);
            }

            return builder.ToString();
        }
    }
}
